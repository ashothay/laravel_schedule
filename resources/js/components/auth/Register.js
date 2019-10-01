import React, {Component} from 'react';
import classNames from 'classnames';
import {Link} from "react-router-dom";

export default class Register extends Component {
    constructor(props) {
        super(props);
        this.state = {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: {}
        };

        this.onSubmit = this.onSubmit.bind(this);
        this.onNameChange = this.onNameChange.bind(this);
        this.onEmailChange = this.onEmailChange.bind(this);
        this.onPasswordChange = this.onPasswordChange.bind(this);
        this.onPasswordConfirmationChange = this.onPasswordConfirmationChange.bind(this);
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

    onSubmit(e) {
        e.preventDefault();

        axios.post(`/register`, _.pick(this.state, ['name', 'email', 'password', 'password_confirmation']))
            .then(() => {
                this.props.history.push(`/users`);
                this.props.onRegister();
            })
            .catch(err => {
                this.setState({errors: err.response.data.errors})
            });
    }


    render() {
        return (
            <div className="card">
                <div className="card-header">Register</div>

                <div className="card-body">
                    <form onSubmit={this.onSubmit}>

                        <div className="form-group row">
                            <label htmlFor="name" className="col-md-4 col-form-label text-md-right">Name</label>

                            <div className="col-md-6">
                                <input id="name" name="name" autoComplete="name" autoFocus required
                                       className={classNames({'is-invalid': this.state.errors.name}, 'form-control')}
                                       onChange={this.onNameChange} value={this.state.name}/>

                                {this.state.errors.name && (
                                    <span className="invalid-feedback" role="alert">
                                        <strong>{this.state.errors.name}</strong>
                                    </span>
                                )}
                            </div>
                        </div>

                        <div className="form-group row">
                            <label htmlFor="email" className="col-md-4 col-form-label text-md-right">
                                E-Mail Address
                            </label>

                            <div className="col-md-6">
                                <input id="email" type="email" name="email" autoComplete="email" autoFocus required
                                       className={classNames({'is-invalid': this.state.errors.email}, 'form-control')}
                                       onChange={this.onEmailChange} value={this.state.email}/>

                                {this.state.errors.email && (
                                    <span className="invalid-feedback" role="alert">
                                        <strong>{this.state.errors.email}</strong>
                                    </span>
                                )}
                            </div>
                        </div>

                        <div className="form-group row">
                            <label htmlFor="password" className="col-md-4 col-form-label text-md-right">Password</label>

                            <div className="col-md-6">
                                <input id="password" type="password" name="password" autoComplete="new-password"
                                       required value={this.state.password} onChange={this.onPasswordChange}
                                       className={classNames({'is-invalid': this.state.errors.password}, 'form-control')}
                                />

                                {this.state.errors.password && (
                                    <span className="invalid-feedback" role="alert">
                                        <strong>{this.state.errors.password}</strong>
                                    </span>
                                )}
                            </div>
                        </div>

                        <div className="form-group row">
                            <label htmlFor="password_confirmation" className="col-md-4 col-form-label text-md-right">
                                Confirm Password
                            </label>

                            <div className="col-md-6">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                       autoComplete="new-password"
                                       required value={this.state.password_confirmation}
                                       onChange={this.onPasswordConfirmationChange}
                                       className={classNames({'is-invalid': this.state.errors.password_confirmation}, 'form-control')}
                                />
                            </div>
                        </div>

                        <div className="form-group row mb-0">
                            <div className="col-md-6 offset-md-4">
                                <button type="submit" className="btn btn-primary">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        );
    }
}
