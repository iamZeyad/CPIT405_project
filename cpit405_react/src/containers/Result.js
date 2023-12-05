
import './Result.css';

const Result = ({ script, describtion }) => {
    return (
        <div className="result-container">
            {describtion && <p className="result-description">Description: {describtion}</p>}
            {script && <p className="result">Script: 
            <p className='result-script'>{script}</p></p>}
        </div>
    );
}

export default Result;
