
import './Result.css';

const Result = ({ script, describtion }) => {
    return (
        <div className="result-container">
            {describtion && <p className="result-description">Description: {describtion}</p>}
            {script && <p className="result-script">Script: {script}</p>}
        </div>
    );
}

export default Result;
