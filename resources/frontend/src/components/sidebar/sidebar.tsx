import { UsersRound, Webhook, Cable } from "lucide-react";
import { Link } from "react-router-dom";
import { Settings } from "./settings";

export function Sidebar() {
    return (
        <aside className="fixed flex h-[100vh] w-[70px] flex-col bg-gray-100 shadow-md shadow-black/25 dark:bg-black/70 dark:shadow-gray-50">
            <div className="flex h-[70px] w-full items-center justify-center">
                <Link to={""}>
                    <Webhook size={32} className="dark:text-green-500" />
                </Link>
            </div>

            <main className="flex w-[70px] flex-1 flex-col justify-between ">
                <ul className="flex w-full flex-col">
                    {/* <Link to={""} className="w-full">
                        <li className="flex w-full justify-center py-2">
                            <Home size={24} />
                        </li>
                    </Link> */}

                    <Link to={"users"} className="w-full">
                        <li className="flex w-full justify-center py-2">
                            <UsersRound size={24} />
                        </li>
                    </Link>

                    <Link
                        to={"analytics-settings"}
                        className="w-full"
                        title="Analytics Configurações"
                    >
                        <li className="flex w-full justify-center py-2">
                            <Cable size={24} />
                        </li>
                    </Link>
                </ul>

                <ul className="flex w-full flex-col">
                    <li className="flex w-full justify-center py-2">
                        <Settings />
                    </li>
                </ul>
            </main>
        </aside>
    );
}
