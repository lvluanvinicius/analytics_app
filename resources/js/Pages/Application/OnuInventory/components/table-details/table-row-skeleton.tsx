import { TableCell, TableRow } from "@/components/ui/table";
import { Skeleton } from "@/components/ui/skeleton";

export function TableDetailRowSkeleton() {
    return (
        <TableRow>
            <TableCell className="whitespace-nowrap">
                <Skeleton className="h-6 w-full rounded-md" />
            </TableCell>
            <TableCell className="whitespace-nowrap ">
                <Skeleton className="h-6 w-full rounded-md" />
            </TableCell>
            <TableCell className="whitespace-nowrap ">
                <Skeleton className="h-6 w-full rounded-md" />
            </TableCell>
            <TableCell className="whitespace-nowrap ">
                <Skeleton className="h-6 w-full rounded-md" />
            </TableCell>
            <TableCell className="whitespace-nowrap ">
                <Skeleton className="h-6 w-full rounded-md" />
            </TableCell>
            <TableCell className="whitespace-nowrap ">
                <Skeleton className="h-6 w-full rounded-md" />
            </TableCell>
            <TableCell className="whitespace-nowrap">
                <Skeleton className="h-6 w-full rounded-md" />
            </TableCell>
        </TableRow>
    );
}
