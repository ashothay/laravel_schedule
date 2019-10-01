import React, {Component} from 'react';
import UserListItem from "./UserListItem";
import {Link} from "react-router-dom";
import queryString from 'querystring';
import ReactPaginate from 'react-paginate';

export default class UserList extends Component {
    constructor(props) {
        super(props);
        this.state = {
            users: [],
            pageCount: 1,
            currentPage: 1,
        };

        this.onPageClick = this.onPageClick.bind(this);
    }

    onUserDelete(id) {
        axios.delete(`/users/${id}`)
            .then(() => {
            this.setState({
                users: this.state.users.filter(user => user.id !== id)
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
        this.setState({currentPage: page || 1}, this.getData);
    }

    getData() {
        axios.get(`/users?page=${this.state.currentPage}`)
            .then(res => [
                this.setState({
                    users: res.data.users.data,
                    can_create: res.data.can_create,
                    currentPage: res.data.users.current_page,
                    pageCount: res.data.users.last_page,
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
                    Users

                    <div className="float-right">
                        {this.state.can_create &&
                        <Link to={`/users/create`} className="btn btn-sm btn-outline-success">Add user</Link>}
                    </div>
                </div>

                <div className="card-body">
                    {this.state.users.map(user => (
                        <UserListItem user={user} onDelete={() => this.onUserDelete(user.id)} key={user.id}/>
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
