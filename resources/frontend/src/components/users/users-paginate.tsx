import { Button } from "../ui/button";

import {
    ChevronLeft,
    ChevronRight,
    ChevronsLeft,
    ChevronsRight,
} from "lucide-react";

export function UsersPaginate() {
    return (
        <div className="mt-4 flex w-full justify-between">
            <div className="">
                <div>Total de 150</div>
            </div>

            <div className="flex items-center justify-normal gap-2">
                <Button variant={"outline"} className="disabled:opacity-50">
                    <ChevronsLeft className="h-4 w-4" />
                </Button>

                <Button variant={"outline"} className="disabled:opacity-50">
                    <ChevronLeft className="h-4 w-4" />
                </Button>

                <Button variant={"outline"} className="disabled:opacity-50">
                    <ChevronRight className="h-4 w-4" />
                </Button>

                <Button variant={"outline"} className="disabled:opacity-50">
                    <ChevronsRight className="h-4 w-4" />
                </Button>
            </div>
        </div>
    );
}
