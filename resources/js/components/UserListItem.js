import React, {Component} from 'react';
import {Link} from "react-router-dom";

export default class UserListItem extends Component {

    render() {
        return (
            <div className="media mb-2">
                <div className="media-body">
                    {this.props.user.name}
                    <div className="float-right">
                        {this.props.user.can_edit && (
                            <Link to={`/users/${this.props.user.id}/edit`} className="btn btn-sm btn-outline-primary">Edit</Link>
                        )}
                        {this.props.user.can_delete && (
                            <button onClick={this.props.onDelete} className="btn btn-sm btn-outline-danger">Delete</button>
                        )}
                    </div>

                </div>
            </div>
        );
    }
}
