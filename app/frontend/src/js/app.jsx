import React from 'react';
import ReactDOM from 'react-dom';
import {
    HashRouter as Router,
    Switch,
    Route
  } from "react-router-dom";
import Head from './components/head';
import MainMenu from './components/main_menu';
import About from './components/pages/about';

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

                <MainMenu />

                <Switch>
                    <Route exact path="/about" component={About} />
                </Switch>
            </div>
        </Router>
    , document.body);
}

ReactDOM.render(<App />, document.getElementById("app"));

