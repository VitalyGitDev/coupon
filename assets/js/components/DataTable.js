import React from 'react';
import Paper from '@material-ui/core/Paper';
import Tooltip from '@material-ui/core/Tooltip';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import TableSortLabel from '@material-ui/core/TableSortLabel';
import Switch from '@material-ui/core/Switch';

export default class DataTable  extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            headerRows: [
                { id: 'id', numeric: true, disablePadding: false, label: "#" },
                { id: 'shop', numeric: false, disablePadding: false, label: "Shop" },
                { id: 'code', numeric: false, disablePadding: false, label: "Code" },
                { id: 'discount', numeric: false, disablePadding: false, label: "Discount" },
                { id: 'destination_url', numeric: false, disablePadding: false, label: "URL" },
                { id: 'start_date', numeric: false, disablePadding: false, label: "ValidFrom" },
                { id: 'expiry_date', numeric: false, disablePadding: false, label: "ExpiryDate" },
                { id: 'created_at', numeric: false, disablePadding: false, label: "DateFound" },
                { id: 'updated_at', numeric: false, disablePadding: false, label: "Updated" },
                { id: null, numeric: false, disablePadding: false, label: "" }
            ],
            order: 'desc',
            orderBy: 'updated_at',
            openTransfersModal: false
        };
    }



    desc(a, b, orderBy) {
        if (b[orderBy] < a[orderBy]) {
            return -1;
        }
        if (b[orderBy] > a[orderBy]) {
            return 1;
        }
        return 0;
    }

    stableSort(array, cmp) {
        const stabilizedThis = array.map((el, index) => [el, index]);
        stabilizedThis.sort((a, b) => {
            const order = cmp(a[0], b[0]);
            if (order !== 0) return order;
            return a[1] - b[1];
        });
        return stabilizedThis.map(el => el[0]);
    }

    getSorting(order, orderBy) {
        return order === 'desc' ? (a, b) => this.desc(a, b, orderBy) : (a, b) => -this.desc(a, b, orderBy);
    }

    createSortHandler(e, orderBy) {
        let order = 'desc';
        if (this.state.orderBy === orderBy && this.state.order === 'desc') {
            order = 'asc';
        }

        this.setState({ order, orderBy });
    }

    render() {
        let that = this;
        let data_source = (this.props.filtering) ? this.props.filtered : this.props.data;
        return (
            <Paper elevation={5} style={{width: "1600px", margin: "10px 0px 5px 25px", padding: "10px"}}>
                <Table aria-labelledby="tableTitle">
                    <TableHead>
                        <TableRow>
                            {this.state.headerRows.map(row => {
                                return (
                                    <TableCell
                                        key={row.id}
                                        numeric={row.numeric}
                                        padding={row.disablePadding ? 'none' : 'default'}
                                        sortDirection={false}
                                    >
                                        <Tooltip
                                            title="Sort"
                                            placement={row.numeric ? 'bottom-end' : 'bottom-start'}
                                            enterDelay={300}
                                        >
                                            <TableSortLabel
                                                active={this.state.orderBy === row.id}
                                                direction={this.state.order}
                                                onClick={(e) => {
                                                    if (row.id) this.createSortHandler(e, row.id)
                                                }}
                                            >
                                                {row.label}
                                            </TableSortLabel>
                                        </Tooltip>
                                    </TableCell>
                                );
                            }, this)}
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {
                            this.stableSort(data_source, this.getSorting(this.state.order, this.state.orderBy)).map((item, i) => {
                                return (
                                    <TableRow
                                        key={item.id}
                                        hover
                                        tabIndex={-1}
                                    >
                                        <TableCell numeric>{item.id}</TableCell>
                                        <TableCell numeric>{item.program.name}</TableCell>
                                        <TableCell numeric>{item.code}</TableCell>
                                        <TableCell>
                                            <Tooltip
                                                title={item.description}
                                            >
                                                <b>{item.discount}</b>
                                            </Tooltip>
                                        </TableCell>
                                        <TableCell>{ item.destination_url }</TableCell>
                                        <TableCell numeric>{item.start_date}</TableCell>
                                        <TableCell numeric>{item.expiry_date}</TableCell>
                                        <TableCell numeric>{item.created_at}</TableCell>
                                        <TableCell numeric>{item.updated_at}</TableCell>
                                        <TableCell numeric>
                                            <Switch
                                                onChange={(e)=>{
                                                    if (confirm('Are you sure?'))
                                                        that.props.dispatch(
                                                            'checkDiscount',
                                                            { id: item.id }
                                                        );
                                                }}

                                            />
                                        </TableCell>
                                    </TableRow>
                                )
                            })
                        }
                    </TableBody>
                </Table>

            </Paper>
        )
    }
}
