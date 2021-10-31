import Providers from "./Providers";
import Deliveries from "./Deliveries";

export default [
    {path: "/providers", component: Providers, name: "Поставщики", icon: "mdi-account-multiple"},
    {path: "/deliveries", component: Deliveries, name: "Поставки", icon: "mdi-truck"}
];