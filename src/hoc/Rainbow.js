import React from 'react';

const Rainbow = (WrappedComponent) => {

    const colours = ['red', 'pink', 'yellow'];
    const randomColor = colours[Math.floor(Math.random() * 2)];

    return (props) => {
         (
            <div className="hello">
                <WrappedComponent {...props} />        
            </div>
        )
    }
}

export default Rainbow;