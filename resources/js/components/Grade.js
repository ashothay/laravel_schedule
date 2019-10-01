import React, {Component} from 'react';
import {Link} from "react-router-dom";
import classNames from 'classnames';
import _ from 'lodash';
import axios from "axios";

export default class Grade extends Component {
    constructor(props) {
        super(props);
        this.state = {
            id: undefined,
            name: '',
            lessons: {},
            _lessons: [],
            schedule: {},
            can_edit: false,
            can_delete: false,
        };

        this.onDelete = this.onDelete.bind(this);
    }

    componentDidMount() {
        const newState = {};
        if ('gradeId' in this.props) {
            newState.id = this.props.gradeId;
        } else if (this.props.match && this.props.match.params.id) {
            newState.id = this.props.match.params.id;
        }
        this.setState(newState, this.getData);
    }

    getData() {
        if (this.state.id) {
            axios.get(`/grades/${this.state.id}`)
                .then(res => res.data)
                .then(data => {
                    this.setState({
                        id: data.grade.id,
                        name: data.grade.name,
                        _lessons: data.grade.lessons,
                        lessons: _.groupBy(data.grade.lessons, 'weekday'),
                        schedule: data.schedule,
                        can_edit: data.can_edit,
                        can_delete: data.can_delete,
                        can_create_lesson: data.can_create_lesson,
                    })
                })
                .catch(err => {
                    console.error(err)
                });
        }
    }

    onDelete() {
        axios.delete(`/grades/${this.state.id}`)
            .then(() => {
                this.props.history.push('/grades');
            })
            .catch(err => {
                console.error(err)
            });
    }

    onLessonDelete(id) {
        axios.delete(`/lessons/${id}`)
            .then(() => {
                this.setState(state => ({
                    _lessons: state._lessons.filter(lesson => lesson.id !== id)
                }), () => {
                    this.setState(state => ({
                        lessons: _.groupBy(state._lessons, 'weekday')
                    }))
                })
            })
            .catch(err => {
                console.error(err)
            });
    }

    render() {
        return (
            <div className="card">
                <div className="card-header">
                    Schedule of Class "{this.state.name}"

                    <div className="float-right">
                        {this.state.can_create_lesson &&
                        <Link to={`/lessons/create?grade_id=${this.state.id}`} className="btn btn-sm btn-outline-success">Add Lesson</Link>
                        }
                        {this.state.can_update &&
                        <Link to={`/lessons/${this.state.id}/edit`}
                              className="btn btn-sm btn-outline-primary">Edit</Link>
                        }
                        {this.state.can_delete &&
                        <button onClick={this.onDelete} className="btn btn-sm btn-outline-danger">Delete</button>
                        }
                    </div>
                </div>

                <div className="card-body">

                    <div className="schedule d-flex align-items-stretch" style={{height: 1310}}>
                        {[0, 1, 2, 3, 4].map(weekday => (
                            <div key={weekday} className="d-flex flex-column flex-grow-1 border border-light">
                                <div className="font-weight-bold text-center mb-3">{window.weekdayNames[weekday]}</div>
                                <div className="h-100 position-relative">
                                    {this.state.lessons[weekday] && this.state.lessons[weekday].map((lesson, i) => (
                                        <div
                                            key={lesson.id}
                                            className={classNames({'bg-info': i % 2}, {'bg-primary': !(i % 2)}, 'schedule__lesson', 'd-flex', 'flex-column', 'justify-content-center', 'align-items-center', 'text-white')}
                                            style={{
                                                height: (lesson.end_date - lesson.start_date) * 100 / this.state.schedule.duration + '%',
                                                top: (lesson.start_date - this.state.schedule.starts_at) * 100 / this.state.schedule.duration + '%',

                                            }}>
                                            <span className="lead font-weight-bold">{lesson.subject.name}</span>
                                            <small>{lesson.teacher.name}</small>
                                            <small>{lesson.starts_at} - {lesson.ends_at}</small>
                                            <Link to={`/lessons/${lesson.id}/edit?grade_id=${this.state.id}`} title="Edit lesson."
                                                  className="schedule__lesson-edit"/>
                                            {this.state.can_delete &&
                                            <button onClick={() => this.onLessonDelete(lesson.id)} title="Delete lesson from Schedule."
                                                    className="btn rounded-0 btn-danger schedule__lesson-delete">&times;</button>
                                            }
                                        </div>
                                    ))}
                                </div>
                            </div>
                        ))}
                    </div>

                </div>
            </div>
        );
    }
}
