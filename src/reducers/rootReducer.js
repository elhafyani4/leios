const initialState = {
    open : false
}
const rootReduder = (state = initialState, action) => {
    if(action.type == "open_menu"){
        return {
            open : true
        }
    }

    if(action.type == "close_menu"){
        return {
            open : false
        }
    }

    return state;
    
}

export default rootReduder;