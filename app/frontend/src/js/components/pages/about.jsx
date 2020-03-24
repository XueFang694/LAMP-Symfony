import React, {useState} from 'react';
import UserListItem from '../user_list_item';

const About = () => 
{
    const [loading, setLoadingStatus] = useState(true);
    const [users, setUsers] = useState(null);

    const getDatas = ( async () =>
    {
        const url = "http://localhost:8080/api-industrie/users";
        const response = await fetch(url);
        const datas = await response.json();
        setUsers(datas["hydra:member"]);
        setLoadingStatus(false);
    })();

    return (
        
        <div>
        {loading || !users ? (<p>Chargement en cours...</p>) :
            (<div>
                <ul>
                    { users.map((user) => {
                     return <UserListItem key={user['id']} userData={user} />;
                    }) }
                </ul>
            </div>) }
        </div>
    );
};

export default About;