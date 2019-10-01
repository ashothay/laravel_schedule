import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter as Router, Switch, Link, Route} from 'react-router-dom';
import UserList from "./components/UserList";
import UserForm from "./components/UserForm";
import GradeList from "./components/GradeList";
import GradeForm from "./components/GradeForm";
import Grade from "./components/Grade";
import LessonForm from "./components/LessonForm";

export default class App extends Component {
    render() {
        return (
            <div>
                <Router>
                    <Switch>
                        <Route path="/" component={GradeList} exact={true} />
                        <Route path="/users/create" component={UserForm} />
                        <Route path="/users/:id/edit" component={UserForm} />
                        <Route path="/users" component={UserList} />
                        <Route path="/grades/create" component={GradeForm} />
                        <Route path="/grades/:id/edit" component={GradeForm} />
                        <Route path="/grades/:id" component={Grade} />
                        <Route path="/grades" component={GradeList} />
                        <Route path="/lessons/:id/edit" component={LessonForm} />
                        <Route path="/lessons/create" component={LessonForm} />
                    </Switch>
                </Router>
            </div>
        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<App/>, document.getElementById('app'));
}
