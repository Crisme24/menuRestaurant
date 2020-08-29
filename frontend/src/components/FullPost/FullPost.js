import React, { Component } from 'react';
import './FullPost.css';
import axios from 'axios'

class FullPost extends Component {
    state = {
        loadedPost: null
    }

    componentDidUpdate() {
        if(this.props.id) {
            axios.get('http://localhost:8000/api/v1/products/' + this.props.id)
            .then(res => {
                //console.log(res);
                this.setState({loadedPost: res.data});
            });
        }
    }
    render () {
        let post = <p style={{textAlign: 'center'}}>Please select a Restaurant!</p>;

        if(this.props.id) {
            post = <p style={{textAlign: 'center'}}>Loading...</p>
        }

        if(this.state.loadedPost) {
            post = (
                <div className="FullPost">
                    <h1>{this.state.loadedPost.name}</h1>
                    <p>{this.state.loadedPost.description}</p>
                    <p>{this.state.loadedPost.address}</p>
                    <p>{this.state.loadedPost.telephone}</p>
                    <div className="Edit">
                        <button className="Delete"></button>
                    </div>
                </div>

            );
        }

        return post;
    }
}

export default FullPost;
