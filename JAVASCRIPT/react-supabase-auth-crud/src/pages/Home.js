import { supabase } from "../supabase/client";
import TaskForm from "../components/TaskForm";
import { useNavigate } from "react-router";
import { useEffect, useState } from "react";
import TaskList from "../components/TaskList";

function Home() {
  const [showTaskDone, setShowTaskDone] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    const checkUser = async () => {
      const { data } = await supabase.auth.getUser();
      if (!data?.user) {
        navigate("/login");
      }
    };
    checkUser();
  }, [navigate]);

  return (
    <div className="row pt-4">
      <div className="col-md-4 offset-md-4">
        <TaskForm setShowTaskDone={setShowTaskDone} />

        <header className="d-flex justify-content-between my-3">
          <span className="h5">{showTaskDone ? "Tareas hechas" : "Tareas sin hacer"}</span>
          <button onClick={() => setShowTaskDone(!showTaskDone)} className="btn btn-dark btn-sm">
            {showTaskDone ? "Mostrar tareas sin hacer" : "Mostrar tareas hechas"}
          </button>
        </header>

        <TaskList done={showTaskDone} />
      </div>
    </div>
  );
}

export default Home;
