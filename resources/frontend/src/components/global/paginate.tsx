import {
    ChevronLeft,
    ChevronRight,
    ChevronsLeft,
    ChevronsRight,
} from "lucide-react";
import { Button } from "../ui/button";

export interface PadinationProps {
    pageIndex: number;
    totalCount: number;
    perPage: number;
    onPageChange: (pageIndex: number) => Promise<void> | void;
}

export function Padination({
    pageIndex,
    perPage,
    totalCount,
    onPageChange,
}: PadinationProps) {
    const pages = Math.ceil(totalCount / perPage) || 1;

    return (
        <div className="flex items-center justify-between">
            <span className="text-sm text-muted-foreground">
                Total {totalCount} item(s)
            </span>

            <div className="flex items-center gap-6 lg:gap-8">
                <div className="flex text-sm font-medium">
                    Página {pageIndex} de {pages}
                </div>
                <div className="flex items-center gap-2">
                    <Button
                        variant={"outline"}
                        className="h-8 w-8 p-0"
                        disabled={pageIndex === 1 || pageIndex === 0}
                        onClick={() => onPageChange(1)}
                    >
                        <ChevronsLeft className="h-4 w-4" />
                        <span className="sr-only">Primeira página</span>
                    </Button>

                    <Button
                        variant={"outline"}
                        className="h-8 w-8 p-0"
                        disabled={pageIndex === 1 || pageIndex === 0}
                        onClick={() => onPageChange(pageIndex - 1)}
                    >
                        <ChevronLeft className="h-4 w-4" />
                        <span className="sr-only">Próxima página</span>
                    </Button>

                    <Button
                        variant={"outline"}
                        className="h-8 w-8 p-0"
                        disabled={pages === pageIndex}
                        onClick={() => onPageChange(pageIndex + 1)}
                    >
                        <ChevronRight className="h-4 w-4" />
                        <span className="sr-only">Página anterior</span>
                    </Button>

                    <Button
                        variant={"outline"}
                        className="h-8 w-8 p-0"
                        onClick={() => onPageChange(pages)}
                        disabled={pages === pageIndex}
                    >
                        <ChevronsRight className="h-4 w-4" />
                        <span className="sr-only">Última página</span>
                    </Button>
                </div>
            </div>
        </div>
    );
}
