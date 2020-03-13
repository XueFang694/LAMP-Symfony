import React, {Component, useState} from 'react';

const ClientForm = (props) =>
{

    const [nouveauClient, setNouveauClient] = useState("");

    const handleChange = (event)=>
    {
        setNouveauClient(event.currentTarget.value);
    }

    const handleSubmit = (event) =>
    {
        event.preventDefault();
        const id = new Date().getTime();
        const nom = nouveauClient;
        props.onClientAdd({id, nom});
        setNouveauClient("");
    }
    return (
        <form onSubmit={handleSubmit}>
            <input
                type="text"
                value={nouveauClient}
                onChange={handleChange}
                placeholder="Nouveau client"
            />
            <button>Ajouter</button>
        </form>
        );

}

export default ClientForm;