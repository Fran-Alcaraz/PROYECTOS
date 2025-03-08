import "./App.css";
import Login from "./pages/Login";
import { Routes, Route } from "react-router";
import Home from "./pages/Home";
import NotFound from "./pages/NotFound";
import { TaskContextProvider } from "./context/TaskContext";
import Navbar from "./components/Navbar";

function App() {
  return (
    <div className="App">
      <TaskContextProvider>
        <Navbar/>
        <div className="container">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/login" element={<Login />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
        </div>
      </TaskContextProvider>
    </div>
  );
}

export default App;
