import { useEffect, useState } from "react";
import { supabase } from "../supabase/client";
import { useNavigate } from "react-router";

function Login() {
  const [email, setEmail] = useState("");
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const result = await supabase.auth.signInWithOtp({
        email,
      });
      console.log(result);
    } catch (error) {
      console.error(error);
    }
  };

  useEffect(() => {
    const checkUser = async () => {
      const { data } = await supabase.auth.getUser();
      if (data?.user) {
        navigate("/");
      }
    };
    checkUser();
  }, [navigate]);

  return (
    <div className="row pt-4">
      <div className="col-md-4 offset-md-4">
        <form onSubmit={handleSubmit} className="card card-body">
          <input
            type="email"
            name="email"
            placeholder="tuemail@dominio.com"
            onChange={(e) => setEmail(e.target.value)}
            className="form-control mb-2"
          />
          <button className="btn btn-primary">Enviar</button>
        </form>
      </div>
    </div>
  );
}

export default Login;
