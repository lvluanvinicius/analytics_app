import { AnalyticsAattenuation } from "@/components/dashboard/analytics-attenuation";
import { Helmet } from "react-helmet-async";

export function Dashboard() {
    return (
        <div>
            <Helmet title="Dashboard" />
            <AnalyticsAattenuation />
        </div>
    );
}
