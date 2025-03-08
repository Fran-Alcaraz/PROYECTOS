import { useTasks } from "../context/TaskContext"

function TaskCard({task}) {
    const {deleteTask, updateTask} = useTasks()

    const handleDelete = () => {
        deleteTask(task.id, task.done)
    }

    const handleToggleDone = () => {
        updateTask(task.id, {done: !task.done})
    }

  return (
    <div className="card card-body mb-2">
      <h5>{task.name}</h5>
      <p>{task.done ? "Hecho ✅" : "Sin hacer ❌"}</p>
      <div>
        <button onClick={() => handleDelete()} className="btn btn-danger btn-sm me-1">Eliminar</button>
        {task.done ? "" : <button onClick={() => handleToggleDone()} className="btn btn-success btn-sm">Hecho</button>}
      </div>
    </div>
  );
}

export default TaskCard;
