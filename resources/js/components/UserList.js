import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import UserListItem from "./UserListItem";
import {Link} from "react-router-dom";

export default class UserList extends Component {
    constructor(props) {
        super(props);
        this.state = {
            users: []
        }
    }

    onUserDelete(id) {
        axios.delete(`/users/${id}`).then(res => [
            this.setState({
                users: this.state.users.filter(user => user.id !== id)
            })
        ]).catch(err => {
            console.error(err)
        });
    }

    componentDidMount() {
        axios.get('/users')
            .then(res => [
                this.setState({
                    users: res.data.users.data,
                    can_create: res.data.can_create
                })
            ]).catch(err => {
            console.error(err)
        });
    }

    render() {
        return (

            <div className="card">
                <div className="card-header">
                    Users

                    <div className="float-right">
                        {this.state.can_create &&
                        <Link to={`/users/create`} className="btn btn-sm btn-outline-success">Add user</Link>}
                    </div>
                </div>

                <div className="card-body">
                    {this.state.users.map(user => (
                        <UserListItem user={user} onDelete={() => this.onUserDelete(user.id)} key={user.id}/>
                    ))}
                </div>
            </div>
        );
    }
}

if (document.getElementById('user-list')) {
    ReactDOM.render(<UserList/>, document.getElementById('user-list'));
}
