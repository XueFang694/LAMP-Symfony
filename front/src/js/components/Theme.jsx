import React, { useContext } from 'react';


import ThemeContext from '../contexts/ThemeContext';

const Theme = () =>{

    const {theme, updateTheme} = useContext(ThemeContext);

    const handleChange = (event)=>
    {
        const value = event.currentTarget.value;
        updateTheme(value);
    }

    return (
        <select name="theme" defaultValue={theme} onChange={handleChange}>
            <option value="dark">Sombre</option>
            <option value="light">Clair</option>
        </select>
    );
}

export default Theme;