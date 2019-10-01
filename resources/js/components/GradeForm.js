import React, {Component} from 'react';
import axios from "axios";
import {Link} from "react-router-dom";
import classNames from 'classnames';

export default class GradeForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            new: true,
            id: undefined,
            name: '',
            errors: {}
        };

        this.onNameChange = this.onNameChange.bind(this);
        this.onSubmit = this.onSubmit.bind(this);
    }

    componentDidMount() {
        const newState = {};
        if ('gradeId' in this.props) {
            newState.id = this.props.gradeId;
            newState.new = false;
        } else if (this.props.match && this.props.match.params.id) {
            newState.id = this.props.match.params.id;
            newState.new = false;
        }
        this.setState(newState, this.getData);
    }

    getData() {
        if (this.state.id) {
            axios.get(`/grades/${this.state.id}/edit`)
                .then(res => res.data)
                .then(data => {
                    this.setState({
                        id: data.grade.id,
                        name: data.grade.name,
                    })
                })
                .catch(err => {
                    console.error(err)
                });
        } else {
            axios.get(`/grades/roles`)
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
            axios.post(`/grades`, data)
                .then(() => {
                    this.props.history.push(`/grades`);
                })
                .catch(err => {
                    this.setState({errors: err.response.data.errors})
                });
        } else {
            data.id = this.state.id;
            axios.put(`/grades/${this.state.id}`, data)
                .then(() => {
                    this.props.history.push(`/grades`);
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

    render() {
        return (
            <div>
                <div className="card">
                    <div className="card-header">{ this.state.new ? 'New Class' : `Editing Class "${this.state.name}"` }</div>

                    <div className="card-body">

                        <form onSubmit={this.onSubmit}>
                            <div className="form-group">
                                <label htmlFor="grade-name-input">Name</label>
                                <input id="grade-name-input" type="text" name="name"
                                       value={this.state.name}
                                       onChange={this.onNameChange}
                                       className={classNames('form-control', {'is-invalid': this.state.errors.name})}/>
                                {this.state.errors.name && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.name}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="float-right">
                                <button type="submit"
                                        className="btn btn-outline-primary">{ this.state.id ? 'Update' : 'Register'}</button>
                                <Link to={`/grades`} className="btn btn-outline-secondary">Cancel</Link>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        );
    }
}
