import React, {Component} from 'react';
import {Link} from "react-router-dom";
import classNames from "classnames";

export default class Header extends Component {
    constructor(props) {
        super(props);

        this.state = {
            isUserDropdownActive: false
        };

        this.onUserDropdownClicked = this.onUserDropdownClicked.bind(this);
        this.onLogout = this.onLogout.bind(this);
    }

    onUserDropdownClicked(e) {
        e.preventDefault();
        this.setState(state => ({isUserDropdownActive: !state.isUserDropdownActive}))
    }

    onLogout(e) {
        e.persist();
        e.preventDefault();
        this.props.onLogout();
    }

    render() {
        return (
            <nav className="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div className="container">
                    <Link className="navbar-brand" to="/">
                        {this.props.app_name}
                    </Link>
                    <button className="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul className="navbar-nav mr-auto">

                        </ul>
                    </div>

                    {!this.props.user && (
                        <ul className="navbar-nav ml-auto">
                            <li className="nav-item">
                                <Link to="/login" className="nav-link">Login</Link>
                            </li>
                            <li className="nav-item">
                                <Link to="/register" className="nav-link">Register</Link>
                            </li>
                        </ul>
                    )}
                    {this.props.user && (
                        <ul className="navbar-nav ml-auto">
                            <li className={classNames({show: this.state.isUserDropdownActive}, 'nav-item', 'dropdown')}>
                                <a id="navbarDropdown" className="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" onClick={this.onUserDropdownClicked}
                                   {...{'aria-expanded': this.state.isUserDropdownActive}}>
                                    {this.props.user.name} <span className="caret"></span>
                                </a>

                                <div
                                    className={classNames({show: this.state.isUserDropdownActive}, 'dropdown-menu', 'dropdown-menu-right')}
                                    aria-labelledby="navbarDropdown">
                                    <a className="dropdown-item" href="/logout" onClick={this.onLogout}>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    )}
                </div>
            </nav>
        );
    }
}
