import { TableCell, TableRow } from "@/components/ui/table";
import { EquipamentPortInterface } from "@/types/equipament-port";

interface TableEquipamentsProps {
    data: EquipamentPortInterface;
}

export function TableEquipamentPortsRow({ data }: TableEquipamentsProps) {
    return (
        <TableRow>
            <TableCell className="whitespace-nowrap">{data.id}</TableCell>
            <TableCell className="whitespace-nowrap">{data.PORT}</TableCell>
        </TableRow>
    );
}
