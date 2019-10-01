import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter as Router, Link, Route, Switch} from 'react-router-dom';
import UserList from "./components/UserList";
import UserForm from "./components/UserForm";
import GradeList from "./components/GradeList";
import GradeForm from "./components/GradeForm";
import Grade from "./components/Grade";
import LessonForm from "./components/LessonForm";
import Login from "./components/auth/Login";
import Register from "./components/auth/Register";
import Header from "./components/common/Header";

export default class App extends Component {
    constructor(props) {
        super(props);
        this.state = {
            app_name: 'School Schedule',
            user: null
        };

        this.onLogout = this.onLogout.bind(this);
        this.onLogin = this.onLogin.bind(this);
    }

    componentDidMount() {
        axios.get('/base-info')
            .then(res => {
                this.setState(_.pick(res.data, ['app_name', 'user']))
            })
    }

    onLogout() {
        axios.post('/logout')
            .then(() => {
                this.setState({user: null})
            })
    }

    onLogin() {
        axios.get('/base-info')
            .then(res => {
                this.setState(_.pick(res.data, ['user']))
            })
    }

    render() {
        return (
            <div>
                <Router>
                    <Header app_name={this.state.app_name} user={this.state.user} onLogout={this.onLogout}/>

                    <main className="py-4">
                        <div className="container">
                            <div className="row justify-content-center">
                                <aside className="col-md-4">
                                    <ul className="list-group">
                                        <li className="list-group-item">
                                            <Link to="/users">Users</Link>
                                        </li>
                                        <li className="list-group-item">
                                            <Link to="/grades">Classes</Link>
                                        </li>
                                    </ul>
                                </aside>
                                <div className="col-md-8">
                                    <Switch>
                                        <Route path="/" component={Register} exact={true}/>
                                        <Route path="/login" render={(props) => (
                                            <Login {...props} onLogin={this.onLogin} />
                                        )} />
                                        <Route path="/register" render={(props) => (
                                            <Register {...props} onRegister={this.onLogin} />
                                        )} />

                                        <Route path="/users/create" component={UserForm}/>
                                        <Route path="/users/:id/edit" component={UserForm}/>
                                        <Route path="/users" component={UserList}/>

                                        <Route path="/grades/create" component={GradeForm}/>
                                        <Route path="/grades/:id/edit" component={GradeForm}/>
                                        <Route path="/grades/:id" component={Grade}/>
                                        <Route path="/grades" component={GradeList}/>

                                        <Route path="/lessons/:id/edit" component={LessonForm}/>
                                        <Route path="/lessons/create" component={LessonForm}/>
                                    </Switch>
                                </div>
                            </div>
                        </div>
                    </main>
                </Router>
            </div>
        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<App/>, document.getElementById('app'));
}
