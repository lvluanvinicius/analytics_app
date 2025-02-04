import {
    Table,
    TableBody,
    TableCell,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { TableEquipamentRow } from "./table-equipament-row";
import { EquipamentInterface } from "@/types/equipament";

interface TableEquipamentsProps {
    equipaments: EquipamentInterface[];
}

export function TableEquipaments({ equipaments }: TableEquipamentsProps) {
    return (
        <Table>
            <TableHeader>
                <TableRow>
                    <TableCell>ID</TableCell>
                    <TableCell>Nome</TableCell>
                    <TableCell>Portas</TableCell>
                    <TableCell></TableCell>
                </TableRow>
            </TableHeader>
            <TableBody>
                {equipaments.map(function (data, index) {
                    return <TableEquipamentRow key={index} data={data} />;
                })}
            </TableBody>
        </Table>
    );
}
