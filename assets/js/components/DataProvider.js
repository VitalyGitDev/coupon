import axios from 'axios';
import React from 'react';

export default class DataProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: [
                //{id: 1, code: 'COUPON031', discount: 5, description: 'long text as description for the coupon.', start_date: '2016-11-27 15:08:07', expiry_date: '2016-11-27 15:08:07'}
            ],
            settings: {},
            filters: {
                name: { label: 'Full Name', selected: null },
                calories: { label: 'Calories', selected: null }
            },
            filtered: [],
            filtering: false,
            first_api_request: true
        }
        this.updateInterval = setInterval(()=>{
            this.dispatch('getCoupons', null);
        }, 2000);
    }

    componentWillUnmount() {
        clearInterval(this.updateInterval);
    }

    dispatch(event, params) {
        switch (event) {
            case 'getCoupons': this.getCoupons();
                break;
            case 'requestAPIData': this.requestFromAPI();
                break;
            case 'checkDiscount': this.checkDiscount(params.id);
                break;
            default: break;
        }
    }

    getCoupons() {
        var that = this;
        axios({
            url: '/coupons',
            method: 'GET',
            responseType: 'application/json',
        }).then((response) => {
            //console.log("Data received: ", response.data);
            that.setState({data: response.data});
        });
    }

    requestFromAPI() {
        var that = this;
        axios({
            url: (this.state.first_api_request) ? '/coupons/request/1' : '/coupons/request/2',
            method: 'GET',
            responseType: 'application/json',
        }).then((response) => {
            this.setState({first_api_request: false});
            alert("Data from API received: " + response.data.message);
        });
    }

    checkDiscount(id) {
        var that = this;
        axios({
            url: '/coupons/' + id + '/mark',
            method: 'GET',
            responseType: 'application/json',
        }).then((response) => {
            //alert("Data from API received: \\r\\n" + response.data.message);
        });
    }

    render() {

        const { children } = this.props;

        const childrenWithProps = React.Children.map(children, child =>
            React.cloneElement(child, {
                data: this.state.data,
                filtered: this.state.filtered,
                filtering: this.state.filtering,
                filters: this.state.filters,
                dispatch: this.dispatch.bind(this)
            })
        );

        return <div>{childrenWithProps}</div>

    }
}
