import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import Client from './components/Client';
import ClientForm from './components/ClientForm';
import Theme from './components/Theme';
import ThemeContext from '../js/contexts/ThemeContext';
import css from "../css/styles.css";

const App = () =>
{

    const [clients, setClients] = useState([
        {id: 1, nom: "Geoffrey LEVENEZ"},
        {id: 2, nom: "numéro 2"},
        {id: 3, nom: "numéro 3"}
    ]);

    const [theme, setTheme] = useState("light");

    const handleAdd = (client) =>
    {
        const updatedClients = [...clients];
        updatedClients.push(client);
        setClients(updatedClients);
    }

    const handleDelete = (id)=>
    {
        const updatedClients = [...clients];
        const index = updatedClients.findIndex((c) => c.id === id);

        updatedClients.splice(index, 1);

        setClients(updatedClients);
    }

    const handleClick = ()=>{

        const updatedClients = [...clients];
        updatedClients.push({id: 4, nom: "Je suis un numéro"})
        updatedClients[0].nom = "DIE";
        setClients(updatedClients);
        console.log(updatedClients);
    };

    const contextValue = {
        theme,
        updateTheme: setTheme
    }

    return (
        <ThemeContext.Provider value={contextValue}>
            <div className={theme}>
                <Theme />
                <button onClick={handleClick}>Hello</button>
            
                <ul>
                {clients.map((client) => (
                    <Client details={client} onDelete={handleDelete}/>
                ))}
                </ul>
                <ClientForm  onClientAdd={handleAdd} />
            </div>
        </ThemeContext.Provider>
    );
}

const rootElement = document.getElementById('root');
rootElement ? ReactDOM.render(<App />, rootElement):false;

