import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter as Router, Link, Route} from 'react-router-dom';
import UserList from "./components/UserList";
import UserForm from "./components/UserForm";

export default class App extends Component {
    render() {
        return (
            <div>
                <Router>
                    <div>
                        <Route path="/" component={UserList} exact={true} />
                        <Route path="/users/create" component={UserForm} />
                        <Route path="/users/:id/edit" component={UserForm} />
                        <Route path="/users" component={UserList} exact={true} />
                    </div>
                </Router>
            </div>
        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<App/>, document.getElementById('app'));
}
