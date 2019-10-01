import React, {Component} from 'react';
import axios from "axios";
import ReactDOM from "react-dom";
import {Link} from "react-router-dom";

export default class UserForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            new: true,
            id: undefined,
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            roles: [],
            allRoles: []
        };

        this.onNameChange = this.onNameChange.bind(this);
        this.onEmailChange = this.onEmailChange.bind(this);
        this.onSubmit = this.onSubmit.bind(this);
        this.onPasswordChange = this.onPasswordChange.bind(this);
        this.onPasswordConfirmationChange = this.onPasswordConfirmationChange.bind(this);
        this.onRolesChange = this.onRolesChange.bind(this);
    }

    componentDidMount() {
        if (this.props.match && this.props.match.params.id) {
            this.setState(state => ({
                ...state,
                new: false
            }));
            axios.get(`/users/${this.props.match.params.id}/edit`)
                .then(res => res.data)
                .then(data => [
                    this.setState(state => ({
                        ...state,
                        id: data.user.id,
                        name: data.user.name,
                        email: data.user.email,
                        roles: data.user.roles || [],
                        allRoles: data.roles || []
                    }))
                ]).catch(err => {
                console.error(err)
            });
        }
    }

    onSubmit(e) {
        e.preventDefault();
        const data = {
            name: this.state.name,
            email: this.state.email,
            password: this.state.password,
            password_confirmation: this.state.password_confirmation,
            roles: this.state.roles
        };

        if (this.state.new) {
            axios.post(`/users`, data)
                .then(res => res.data)
                .then(res => {
                    this.setState(state => ({
                        ...state,
                        name: data.name,
                        email: data.email,
                        roles: data.roles || []
                    }));
                    this.props.history.push(`/users`);
                }).catch(err => {
                console.error(err)
            });
        } else {
            data.id = this.state.id;
            axios.put(`/users/${this.state.id}`, data)
                .then(res => res.data)
                .then(res => {
                    this.setState(state => ({
                        ...state,
                        name: data.name,
                        email: data.email,
                        roles: data.roles || []
                    }));
                    this.props.history.push(`/users`);
                }).catch(err => {
                console.error(err)
            });
        }
    }

    onNameChange(e) {
        e.persist();
        this.setState(state => ({
            ...state,
            name: e.target.value
        }))
    }

    onEmailChange(e) {
        e.persist();
        this.setState(state => ({
            ...state,
            email: e.target.value
        }))
    }

    onPasswordChange(e) {
        e.persist();
        this.setState(state => ({
            ...state,
            password: e.target.value
        }))
    }

    onPasswordConfirmationChange(e) {
        e.persist();
        this.setState(state => ({
            ...state,
            password_confirmation: e.target.value
        }))
    }

    onRolesChange(e) {
        e.persist();
        const options = e.target.options;
        const value = [];
        for (let i = 0, l = options.length; i < l; i++) {
            if (options[i].selected) {
                value.push(options[i].value);
            }
        }
        this.setState(state => ({
            ...state,
            roles: value
        }));
    }

    render() {
        return (
            <div>
                <div className="card">
                    <div className="card-header">Teachers</div>

                    <div className="card-body">

                        <form onSubmit={this.onSubmit}>
                            <div className="form-group">
                                <label htmlFor="user-name-input">Name</label>
                                <input id="user-name-input" type="text" name="name"
                                       value={this.state.name}
                                       onChange={this.onNameChange}
                                       className="form-control"/>
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-email-input">E-mail</label>
                                <input id="user-email-input" type="text" name="email"
                                       value={this.state.email}
                                       onChange={this.onEmailChange}
                                       className="form-control"/>
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-password-input">Password</label>
                                <input id="user-password-input" type="password" name="password"
                                       value={this.state.password}
                                       onChange={this.onPasswordChange}
                                       className="form-control"/>
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-password-input">Password Confirmation</label>
                                <input id="user-password-input" type="password" name="password_confirmation"
                                       value={this.state.password_confirmation}
                                       onChange={this.onPasswordConfirmationChange}
                                       className="form-control"/>
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-role-input">Roles</label>
                                <select name="roles[]" id="user-role-input" className="form-control"
                                        multiple="multiple" value={this.state.roles} onChange={this.onRolesChange}>
                                    {Object.keys(this.state.allRoles).map(role => (
                                        <option key={role} value={role}>{this.state.allRoles[role]}</option>
                                    ))}
                                </select>
                            </div>
                            <div className="float-right">
                                <button type="submit"
                                        className="btn btn-outline-primary">{ this.state.id ? 'Update' : 'Register'}</button>
                                <Link to={`/users`} className="btn btn-outline-secondary">Cancel</Link>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        );
    }
}
