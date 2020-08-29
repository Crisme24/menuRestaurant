import React from 'react';

import './Post.css';

const post = (props) => (
    <article className="Post" onClick={props.clicked}>
        <img src={props.image} alt=""></img>
        <div className="Info">
            <div className="Author">{props.name}</div>
        </div>
    </article>
);

export default post;
