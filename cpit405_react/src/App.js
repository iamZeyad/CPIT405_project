import About from "./containers/About";
import Home from "./containers/Home";
import List from "./containers/List";
import { BrowserRouter, Routes, Route, Link } from "react-router-dom";
import "./App.css";

export default function App() {
  return (
    <BrowserRouter>
      <div className="container">
        <header>
          <nav className="navbar">
            <ul>
              <li>
                <Link to="/">Home</Link>
              </li>
              <li>
                <Link to="/List">List</Link>
              </li>
              <li>
                <Link to="/About">About</Link>
              </li>
            </ul>
          </nav>
        </header>
        <main>
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/List" element={<List />} />
            <Route path="/About" element={<About />} />
          </Routes>
        </main>
        <footer>
          <div className="copyright">
            <p>&copy; 2023 COL@. All rights reserved.</p>
          </div>
        </footer>
      </div>
    </BrowserRouter>
  );
}