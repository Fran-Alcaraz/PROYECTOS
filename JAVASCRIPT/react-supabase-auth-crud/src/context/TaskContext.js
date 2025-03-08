import { createContext, useContext, useState } from "react";
import { supabase } from "../supabase/client";

export const TaskContext = createContext()

export const useTasks = () => {
    const context = useContext(TaskContext)
    return context
}

export const TaskContextProvider = ({children}) => {
    const [tasks, setTasks] = useState([])
    const [adding, setAdding] = useState(false)
    const [loading, setLoading] = useState(false)

    const getTasks = async (done = false) => {
        setLoading(true)
        const {data:{user}} = await supabase.auth.getUser()

        if(!user){
            setTasks([])
            setLoading(false)
            return
        }

        const {error, data} = await supabase.from("tasks").select().eq("userId", user.id).eq("done", done).order("id", {ascending: true})
        if(error) throw error
        setTasks(data)
        setLoading(false)
    }

    const createTask = async (taskName) => {
        setAdding(true)
        try{
            const { data: { user } } = await supabase.auth.getUser()
            const {error} = await supabase.from("tasks").insert({
                name: taskName,
                userId: user.id
            })

            if(error) throw error

            await getTasks()
            
        } catch(error){
            console.error(error)
        }
        setAdding(false)
    }

    const deleteTask = async (id, done) => {
        const { data: { user } } = await supabase.auth.getUser()

        const {error} = await supabase.from("tasks").delete().eq("userId", user.id).eq("id", id)

        if(error) throw error

        await getTasks(done)
    }

    const updateTask = async (id, updateFields) => {
        const { data: { user } } = await supabase.auth.getUser()

        const {error} = await supabase.from("tasks").update(updateFields).eq("userId", user.id).eq("id", id)

        if(error) throw error

        await getTasks()
    }

    return <TaskContext.Provider value={{tasks, getTasks, createTask, adding, loading, deleteTask, updateTask}}>
        {children}
    </TaskContext.Provider>
}