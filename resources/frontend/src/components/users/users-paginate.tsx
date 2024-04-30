import { Button } from "../ui/button";

import {
    ChevronLeft,
    ChevronRight,
    ChevronsLeft,
    ChevronsRight,
  } from 'lucide-react'

export function UsersPaginate() {

    return <div className="mt-4 w-full flex justify-between">
        <div className="">
            <div>Total de 150</div>
        </div>

        <div className="flex items-center justify-normal gap-2">
            <Button variant={'outline'} className="disabled:opacity-50">
                <ChevronsLeft className="w-4 h-4"/>
            </Button>

            <Button variant={'outline'} className="disabled:opacity-50">
                <ChevronLeft className="w-4 h-4"/>
            </Button>

            <Button variant={'outline'} className="disabled:opacity-50">
                <ChevronRight className="w-4 h-4"/>
            </Button>

            <Button variant={'outline'} className="disabled:opacity-50">
                <ChevronsRight className="w-4 h-4"/>
            </Button>
        </div>
    </div>
}