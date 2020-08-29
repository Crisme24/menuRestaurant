import React, { Component } from 'react';
import Post from '../../components/Post/Post';
import FullPost from '../../components/FullPost/FullPost';
//import NewPost from '../../components/NewPost/NewPost';
import './Blog.css';
import axios from 'axios';


class Blog extends Component {
    state = {
        posts: [],
        selectedPostId: null
    }

    componentDidMount () {
        axios.get('http://localhost:8000/api/v1/products')
        .then(res => {
            this.setState({posts: res.data})
            //console.log(res)
        })
        .catch(console.error)
    }

    postSelectHandler = (id) => {
        this.setState({selectedPostId: id})
    }

    render () {
        const posts = this.state.posts.map(post => {
            return <Post
            key={post.id}
            image={post.image_path}
            name={post.name}
            clicked={() => this.postSelectHandler(post.id)}/>
        })
        return (
            <div>
                <section className="Posts">
                    {posts}
                </section>
                <section>
                    <br/>
                    <br/>
                    <FullPost id={this.state.selectedPostId} />
                </section>
                <section>

                </section>
            </div>
        );
    }
}

export default Blog;
