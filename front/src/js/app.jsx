import React from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link
  } from "react-router-dom";
import Head from './components/head'

import css from "../css/styles.css";

const App = () =>
{
    return ReactDOM.createPortal(
        <Router>
            <div>
                {/* Debut ./components/head */}
                <Head>
                    <title>Hello world</title>
                </Head>
                {/* Fin ./components/head */}

                <nav>
                    <ul>
                        <li>
                        <Link to="/">Home</Link>
                        </li>
                        <li>
                        <Link to="/about">About</Link>
                        </li>
                        <li>
                        <Link to="/users">Users</Link>
                        </li>
                    </ul>
                </nav>

                <Switch>
                    {/* 
                    <Route path="/about">
                        <About />
                    </Route>
                    */}
                </Switch>
            </div>
        </Router>
    , document.body);
}

ReactDOM.render(<App />, document.getElementById("app"));

