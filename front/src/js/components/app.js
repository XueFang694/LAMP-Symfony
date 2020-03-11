import React from 'react';
import ReactDOM from 'react-dom';

class App extends React.Component
{
    state = {
        clients: 
        [
            {id: 1, nom: "Geoffrey LEVENEZ"},
            {id: 2, nom: "numéro 2"},
            {id: 3, nom: "numéro 3"}
        ]
    };

    handleClick = ()=>{

        let myClients = [...this.state.clients];
        myClients[0].nom = "DIE";
        this.setState({clients: myClients});
        console.log(myClients)
    };

    render()
    {
        const title = "My title 2";
        return (
            <div>
                <button onClick={this.handleClick}>Hello</button>
            
                <ul>
                    {this.state.clients.map((c) => <li>{c.nom}</li>)}
                </ul>
            </div>
        );
    };
}

const rootElement = document.getElementById('root');
rootElement ? ReactDOM.render(<App />, rootElement):false;