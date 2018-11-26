import React from 'react';
import Paper from '@material-ui/core/Paper';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import Button from '@material-ui/core/Button';
import CachedIcon from '@material-ui/icons/Cached';

const Filters = (props) => {

    return (
        <Paper elevation={5} style={{ width: "1600px", margin: "10px 0px 5px 25px", padding: "10px" }}>
            <InputLabel>Press it to request data from remote API:__</InputLabel>
            <Button
                variant="fab"
                color="primary"
                aria-label="Add"
                onClick={(e)=>{
                    props.dispatch(
                        'requestAPIData',
                        {  }
                    );
                }}
            >
                <CachedIcon />
            </Button>
        </Paper>
    );
};

export default Filters