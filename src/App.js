import React, {useRef} from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import Button from '@material-ui/core/Button';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';
import Drawer from './drawer';
import { connect, Provider } from 'react-redux';
import {openDrawer, closeDrawer} from './redux/actions';


const styles = {
  root: {
    flexGrow: 1,
  },
  grow: {
    flexGrow: 1,
  },
  menuButton: {
    marginLeft: -12,
    marginRight: 20,
  },
};

class ButtonAppBar extends React.Component{
  constructor(props){
    super(props);
  }

  


  render(){
    return (
      <div className={this.props.classes.root}>
        <AppBar position="static">
        
          <Toolbar>
            <IconButton onClick={this.props.openDrawer} className={this.props.classes.menuButton}color="inherit" aria-label="Menu">
              <MenuIcon />
            </IconButton>
            <Typography variant="h6" color="inherit" className={this.props.classes.grow}>
                News
            </Typography>
            <Button color="inherit">Login</Button>
          </Toolbar>
          <Drawer />
        </AppBar>
      </div>
    );
  }

} 


ButtonAppBar.propTypes = {
  classes: PropTypes.object.isRequired,
};

const mapStateToProps = state => ({
  ...state
});
const mapDispatchToProps = dispatch => ({
  startAction: () => dispatch(startAction),
  stopAction: () => dispatch(stopAction)
});

export default connect((mapStateToProps, mapDispatchToProps))(withStyles(styles)(ButtonAppBar));



// import React from 'react';
// import PropTypes from 'prop-types';

// class App extends React.Component{
//  constructor(options){
//    super(options);
   
//    this.state = {
//     currentTime: (new Date()).toISOString()
//    }
//  }

// launchClock = () => {
//   setInterval(() => {
//     console.log("hello world");
//     this.setState({
//       currentTime: (new Date()).toISOString()
//     })
//   }, 10)
// }

//  render(){
//    return (<div>
//       {this.state.currentTime}
//     </div>)
//  }
// }

// export default App;