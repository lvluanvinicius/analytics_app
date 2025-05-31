import { TableCell, TableRow } from "@/components/ui/table";
import { EquipamentInterface } from "@/types/equipament";

interface TableEquipamentsProps {
    data: EquipamentInterface;
}

export function TableEquipamentRow({ data }: TableEquipamentsProps) {
    return (
        <TableRow>
            <TableCell className="whitespace-nowrap">{data.id}</TableCell>
            <TableCell className="whitespace-nowrap">{data.DEVICE}</TableCell>
        </TableRow>
    );
}
