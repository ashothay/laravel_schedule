import React, {Component} from 'react';
import axios from "axios";
import {Link} from "react-router-dom";
import classNames from 'classnames';

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
            allRoles: [],
            errors: {}
        };

        this.onNameChange = this.onNameChange.bind(this);
        this.onEmailChange = this.onEmailChange.bind(this);
        this.onSubmit = this.onSubmit.bind(this);
        this.onPasswordChange = this.onPasswordChange.bind(this);
        this.onPasswordConfirmationChange = this.onPasswordConfirmationChange.bind(this);
        this.onRolesChange = this.onRolesChange.bind(this);
    }

    componentDidMount() {
        const newState = {};
        if ('userId' in this.props) {
            newState.id = this.props.userId;
            newState.new = false;
        } else if (this.props.match && this.props.match.params.id) {
            newState.id = this.props.match.params.id;
            newState.new = false;
        }
        this.setState(newState, this.getData);
    }

    getData() {
        if (this.state.id) {
            axios.get(`/users/${this.state.id}/edit`)
                .then(res => res.data)
                .then(data => {
                    this.setState({
                        id: data.user.id,
                        name: data.user.name,
                        email: data.user.email,
                        roles: data.user.roles || [],
                        allRoles: data.roles || []
                    })
                })
                .catch(err => {
                    console.error(err)
                });
        } else {
            axios.get(`/users/roles`)
                .then(res => res.data)
                .then(data => {
                    this.setState(state => ({
                        allRoles: data.roles || []
                    }));
                })
                .catch(err => {
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
                .then(() => {
                    this.props.history.push(`/users`);
                })
                .catch(err => {
                    this.setState({errors: err.response.data.errors})
                });
        } else {
            data.id = this.state.id;
            axios.put(`/users/${this.state.id}`, data)
                .then(() => {
                    this.props.history.push(`/users`);
                })
                .catch(err => {
                    this.setState({errors: err.response.data.errors})
                });
        }
    }

    onNameChange(e) {
        e.persist();
        this.setState({name: e.target.value})
    }

    onEmailChange(e) {
        e.persist();
        this.setState({email: e.target.value})
    }

    onPasswordChange(e) {
        e.persist();
        this.setState({password: e.target.value})
    }

    onPasswordConfirmationChange(e) {
        e.persist();
        this.setState({password_confirmation: e.target.value})
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
        this.setState({roles: value});
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
                                       className={classNames('form-control', {'is-invalid': this.state.errors.name})}/>
                                {this.state.errors.name && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.name}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-email-input">E-mail</label>
                                <input id="user-email-input" type="text" name="email"
                                       value={this.state.email}
                                       onChange={this.onEmailChange}
                                       className={classNames('form-control', {'is-invalid': this.state.errors.email})}/>
                                {this.state.errors.email && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.email}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-password-input">Password</label>
                                <input id="user-password-input" type="password" name="password"
                                       value={this.state.password}
                                       onChange={this.onPasswordChange}
                                       className={classNames('form-control', {'is-invalid': this.state.errors.password})}/>
                                {this.state.errors.password && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.password}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-password-confirmation-input">Password Confirmation</label>
                                <input id="user-password-confirmation-input" type="password"
                                       name="password_confirmation"
                                       value={this.state.password_confirmation}
                                       onChange={this.onPasswordConfirmationChange}
                                       className="form-control"/>
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-role-input">Roles</label>
                                <select name="roles[]" id="user-role-input" multiple="multiple" value={this.state.roles}
                                        className={classNames('form-control', {'is-invalid': this.state.errors.roles})}
                                        onChange={this.onRolesChange}>
                                    {Object.keys(this.state.allRoles).map(role => (
                                        <option key={role} value={role}>{this.state.allRoles[role]}</option>
                                    ))}
                                </select>
                                {this.state.errors.roles && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.roles}</strong>
                                    </div>
                                )}
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
