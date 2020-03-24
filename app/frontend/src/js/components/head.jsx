import ReactDOM from 'react-dom';

const Head = ({children})=>
{
    // Récupère le tag <head>
    const headRoot = document.head;

    // Récupère les noeuds enfants transmis par le composant parent
    return ReactDOM.createPortal(
        children, headRoot
    );
};

export default Head;