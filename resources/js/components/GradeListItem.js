import React, {Component} from 'react';
import {Link} from "react-router-dom";

export default class GradeListItem extends Component {
    render() {
        return (
            <div className="media mb-2">
                <div className="media-body">
                    <Link to={`/grades/${this.props.grade.id}`}>{this.props.grade.name}</Link>
                    <div className="float-right">
                        {this.props.grade.can_edit && (
                            <Link to={`/grades/${this.props.grade.id}/edit`} className="btn btn-sm btn-outline-primary">Edit</Link>
                        )}
                        {this.props.grade.can_delete && (
                            <button onClick={this.props.onDelete} className="btn btn-sm btn-outline-danger">Delete</button>
                        )}
                    </div>

                </div>
            </div>
        );
    }
}
