import React, {Component} from 'react';
import classNames from 'classnames';
import {Link} from "react-router-dom";

export default class Login extends Component {
    constructor(props) {
        super(props);
        this.state = {
            email: '',
            password: '',
            remember: false,
            errors: {}
        };

        this.onSubmit = this.onSubmit.bind(this);
        this.onEmailChange = this.onEmailChange.bind(this);
        this.onPasswordChange = this.onPasswordChange.bind(this);
        this.onRememberChange = this.onRememberChange.bind(this);
    }

    onEmailChange(e) {
        e.persist();
        this.setState({email: e.target.value})
    }

    onPasswordChange(e) {
        e.persist();
        this.setState({password: e.target.value})
    }

    onRememberChange(e) {
        e.persist();
        this.setState({remember: e.target.value})
    }

    onSubmit(e) {
        e.preventDefault();

        axios.post(`/login`, _.pick(this.state, ['email', 'password', 'remember']))
            .then(() => {
                this.props.history.push(`/users`);
                this.props.onLogin();
            })
            .catch(err => {
                console.error(err);
                this.setState({errors: err.response.data.errors})
            });
    }


    render() {
        return (
            <div className="card">
                <div className="card-header">Login</div>

                <div className="card-body">
                    <form onSubmit={this.onSubmit}>

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
                                <input id="password" type="password" name="password" autoComplete="current-password"
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
                            <div className="col-md-6 offset-md-4">
                                <div className="form-check">
                                    <input className="form-check-input" type="checkbox" name="remember"
                                           id="remember" value={this.state.remember} onChange={this.onRememberChange}/>

                                    <label className="form-check-label" htmlFor="remember">Remember Me</label>
                                </div>
                            </div>
                        </div>

                        <div className="form-group row mb-0">
                            <div className="col-md-8 offset-md-4">
                                <button type="submit" className="btn btn-primary">Login</button>

                                {/*<Link to="/password/reset" className="btn btn-link">Forgot Your Password?</Link>*/}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        );
    }
}
