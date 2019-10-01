import React, {Component} from 'react';
import axios from 'axios';
import GradeListItem from "./GradeListItem";
import {Link} from "react-router-dom";
import queryString from 'querystring';
import ReactPaginate from "react-paginate";

export default class GradeList extends Component {
    constructor(props) {
        super(props);
        this.state = {
            grades: [],
            pageCount: 1,
            currentPage: 1,
        };

        this.onPageClick = this.onPageClick.bind(this);
    }

    onGradeDelete(id) {
        axios.delete(`/grades/${id}?page=${this.state.currentPage}`)
            .then(() => {
                this.setState({
                    grades: this.state.grades.filter(grade => grade.id !== id)
                })
            })
            .catch(err => {
                console.error(err)
            });
    }

    async onPageClick(data) {
        const page = data.selected >= 0 ? data.selected + 1 : 0;
        this.setState({currentPage: page}, this.getData);
    }

    componentDidMount() {
        const page = Number(queryString.parse(this.props.location.search.substr(1)).page);
        this.setState({ currentPage: page || 1 }, this.getData);
    }

    getData() {
        axios.get(`/grades?page=${this.state.currentPage}`)
            .then(res => [
                this.setState({
                    grades: res.data.grades.data,
                    can_create: res.data.can_create,
                    currentPage: res.data.grades.current_page,
                    pageCount: res.data.grades.last_page,
                })
            ])
            .catch(err => {
                console.error(err)
            });
    }

    render() {
        return (

            <div className="card">
                <div className="card-header">
                    Classes

                    <div className="float-right">
                        {this.state.can_create &&
                        <Link to={`/grades/create`} className="btn btn-sm btn-outline-success">Add class</Link>}
                    </div>
                </div>

                <div className="card-body">
                    {this.state.grades.map(grade => (
                        <GradeListItem grade={grade} onDelete={() => this.onGradeDelete(grade.id)} key={grade.id}/>
                    ))}
                    {this.state.pageCount > 1 &&
                    <ReactPaginate
                        pageCount={this.state.pageCount}
                        initialPage={this.state.currentPage - 1}
                        forcePage={this.state.currentPage - 1}
                        pageRangeDisplayed={4}
                        marginPagesDisplayed={2}
                        previousLabel="&#x276E;"
                        nextLabel="&#x276F;"
                        containerClassName="pagination justify-content-center"
                        pageClassName="page-item"
                        pageLinkClassName="page-link"
                        nextClassName="page-item"
                        previousClassName="page-item"
                        nextLinkClassName="page-link"
                        previousLinkClassName="page-link"
                        activeClassName="active"
                        disabledClassName="disabled"
                        onPageChange={this.onPageClick}
                        disableInitialCallback={true}
                        hrefBuilder={() => "#"}
                    />
                    }
                </div>
            </div>
        );
    }
}
