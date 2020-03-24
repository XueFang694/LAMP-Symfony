import React from 'react';

const UserListItem = ({userData}) =>
{
    return (<li>{userData['username']}</li>);
}

export default UserListItem;