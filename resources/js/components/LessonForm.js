import React, {Component} from 'react';
import {Link} from "react-router-dom";
import classNames from 'classnames';
import queryString from "querystring";

export default class LessonForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            new: true,
            id: undefined,
            grade_id: undefined,
            weekday: undefined,
            subject_id: undefined,
            teacher_id: undefined,
            starts_at: '',
            ends_at: '',
            grades: [],
            subjects: [],
            teachers: [],
            errors: {},
        };

        this.onGradeChange = this.onGradeChange.bind(this);
        this.onWeekdayChange = this.onWeekdayChange.bind(this);
        this.onSubjectChange = this.onSubjectChange.bind(this);
        this.onTeacherChange = this.onTeacherChange.bind(this);
        this.onStartChange = this.onStartChange.bind(this);
        this.onEndChange = this.onEndChange.bind(this);
        this.onSubmit = this.onSubmit.bind(this);
    }

    componentDidMount() {
        const newState = {};

        const grade_id = Number(queryString.parse(this.props.location.search.substr(1)).grade_id);
        if (!isNaN(grade_id)) {
            newState.grade_id = grade_id
        }

        if ('lessonId' in this.props) {
            newState.id = this.props.lessonId;
            newState.new = false;
        } else if (this.props.match && this.props.match.params.id) {
            newState.id = this.props.match.params.id;
            newState.new = false;
        }
        this.setState(newState, this.getData);
    }

    getData() {
        if (this.state.id) {
            axios.get(`/lessons/${this.state.id}/edit`)
                .then(res => res.data)
                .then(data => {
                    this.setState({
                        id: data.lesson.id,
                        grade_id: data.lesson.grade_id,
                        weekday: data.lesson.weekday,
                        subject_id: data.lesson.subject_id,
                        teacher_id: data.lesson.teacher_id,
                        starts_at: data.lesson.starts_at,
                        ends_at: data.lesson.ends_at,
                        grades: data.grades,
                        subjects: data.subjects,
                        teachers: data.teachers,
                    })
                })
                .catch(err => {
                    console.error(err)
                });
        } else {
            axios.get(`/lessons/create`)
                .then(res => res.data)
                .then(data => {
                    this.setState({
                        grades: data.grades,
                        subjects: data.subjects,
                        teachers: data.teachers,
                    })
                })
                .catch(err => {
                    console.error(err)
                });
        }
    }

    onSubmit(e) {
        e.preventDefault();
        const data = _.pick(this.state, ['grade_id', 'weekday', 'subject_id', 'teacher_id', 'starts_at', 'ends_at']);
        data.starts_at = data.starts_at.substring(0, 5);
        data.ends_at = data.ends_at.substring(0, 5);

        if (this.state.new) {
            axios.post(`/lessons`, data)
                .then(() => {
                    this.props.history.push(`/grades/${this.state.grade_id}`);
                })
                .catch(err => {
                    this.setState({errors: err.response.data.errors})
                });
        } else {
            data.id = this.state.id;
            axios.put(`/lessons/${this.state.id}`, data)
                .then(() => {
                    this.props.history.push(`/grades/${this.state.grade_id}`);
                })
                .catch(err => {
                    this.setState({errors: err.response.data.errors})
                });
        }
    }

    onGradeChange(e) {
        e.persist();
        this.setState({grade_id: e.target.value})
    }

    onWeekdayChange(e) {
        e.persist();
        this.setState({weekday: e.target.value})
    }

    onSubjectChange(e) {
        e.persist();
        this.setState({subject_id: e.target.value})
    }

    onTeacherChange(e) {
        e.persist();
        this.setState({teacher_id: e.target.value})
    }

    onStartChange(e) {
        e.persist();
        this.setState({starts_at: e.target.value})
    }

    onEndChange(e) {
        e.persist();
        this.setState({ends_at: e.target.value})
    }

    render() {
        return (
            <div>
                <div className="card">
                    <div className="card-header">{this.state.new ? 'New Lesson' : `Editing Lesson`}</div>

                    <div className="card-body">

                        <form onSubmit={this.onSubmit}>
                            <div className="form-group">
                                <label htmlFor="user-class-input">Class</label>
                                <select id="user-class-input" value={this.state.grade_id}
                                        className={classNames('form-control', {'is-invalid': this.state.errors.grade_id})}
                                        onChange={this.onGradeChange}>
                                    {this.state.grades.map(grade => (
                                        <option key={grade.id} value={grade.id}>{grade.name}</option>
                                    ))}
                                </select>
                                {this.state.errors.grade_id && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.grade_id}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-weekday-input">Week Day</label>
                                <select id="user-weekday-input" value={this.state.weekday}
                                        className={classNames('form-control', {'is-invalid': this.state.errors.weekday})}
                                        onChange={this.onWeekdayChange}>
                                    {[0, 1, 2, 3, 4].map(weekday => (
                                        <option key={weekday} value={weekday}>{window.weekdayNames[weekday]}</option>
                                    ))}
                                </select>
                                {this.state.errors.weekday && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.weekday}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-subject-input">Subject</label>
                                <select id="user-subject-input" value={this.state.subject_id}
                                        className={classNames('form-control', {'is-invalid': this.state.errors.subject_id})}
                                        onChange={this.onSubjectChange}>
                                    {this.state.subjects.map(subject => (
                                        <option key={subject.id} value={subject.id}>{subject.name}</option>
                                    ))}
                                </select>
                                {this.state.errors.subject_id && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.subject_id}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-teacher-input">Teacher</label>
                                <select id="user-teacher-input" value={this.state.teacher_id}
                                        className={classNames('form-control', {'is-invalid': this.state.errors.teacher_id})}
                                        onChange={this.onTeacherChange}>
                                    {this.state.teachers.map(teacher => (
                                        <option key={teacher.id} value={teacher.id}>{teacher.name}</option>
                                    ))}
                                </select>
                                {this.state.errors.subject_id && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.subject_id}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-starts_at-input">Starts at</label>
                                <input id="user-starts_at-input" value={this.state.starts_at}
                                       onChange={this.onStartChange} type="time" pattern="[0-9]{2}:[0-9]{2}"
                                       className={classNames('form-control', {'is-invalid': this.state.errors.starts_at})}/>
                                {this.state.errors.starts_at && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.starts_at}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="user-ends_at-input">Ends at</label>
                                <input id="user-ends_at-input" value={this.state.ends_at}
                                       onChange={this.onEndChange} type="time" pattern="[0-9]{2}:[0-9]{2}"
                                       className={classNames('form-control', {'is-invalid': this.state.errors.ends_at})}/>
                                {this.state.errors.ends_at && (
                                    <div className="invalid-feedback">
                                        <strong>{this.state.errors.ends_at}</strong>
                                    </div>
                                )}
                            </div>
                            <div className="float-right">
                                <button type="submit"
                                        className="btn btn-outline-primary">{this.state.id ? 'Update' : 'Add'}</button>
                                <Link to={`/grades/${this.state.grade_id}`}
                                      className="btn btn-outline-secondary">Cancel</Link>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        )
    }
}
