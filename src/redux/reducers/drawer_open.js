import {action_type} from '../actionTypes';

export default (state = false, action ) => {
    console.log(action.type);
    switch(action.type){
        
        case action_type.OPEN_DRAWER: {
            return { openClose: action.payload };
        }
        default:{
            return state;
        }
    }
}

