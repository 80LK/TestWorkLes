import Home from "./Home";
import routes from "./routes";

export default [
    { path:"/", component:Home, title: "Главная" },
    ...routes
];