import React from 'react';
import DataProvider from './DataProvider';
import DataTable from './DataTable';
import Filters from './Filters';

export default class App extends React.Component {

    render() {
        return (
            <DataProvider>
                <Filters />
                <DataTable />
            </DataProvider>
        )
    }
}