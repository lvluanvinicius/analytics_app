import { UsersRound } from "lucide-react";
import { Home } from "lucide-react";
import { Webhook } from "lucide-react";
import { Link } from "react-router-dom";
import { ModeToggle } from "../themes/mode-toggle";

export function Sidebar() {
    return (
        <aside className="flex h-[100vh] w-[70px] flex-col shadow-md shadow-black/10 dark:shadow-gray-50">
            <div className="flex h-[70px] w-full items-center justify-center">
                <Webhook size={32} className="dark:text-green-500" />
            </div>
            <main className="flex flex-1 flex-col justify-between">
                <ul className="flex w-full flex-col">
                    <Link to={""} className="w-full">
                        <li className="flex w-full justify-center py-2">
                            <Home size={24} />
                        </li>
                    </Link>

                    <Link to={"users"} className="w-full">
                        <li className="flex w-full justify-center py-2">
                            <UsersRound size={24} />
                        </li>
                    </Link>
                </ul>

                <ul className="flex w-full flex-col">
                    <li className="flex w-full justify-center py-2">
                        <ModeToggle />
                    </li>
                </ul>
            </main>
        </aside>
    );
}
