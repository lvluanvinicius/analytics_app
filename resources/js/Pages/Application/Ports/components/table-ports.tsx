import {
    Table,
    TableBody,
    TableCell,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { TableEquipamentPortsRow } from "./table-port-row";
import { EquipamentPortInterface } from "@/types/equipament-port";

interface TableEquipamentsProps {
    ports: EquipamentPortInterface[];
}

export function TableEquipamentPorts({ ports }: TableEquipamentsProps) {
    return (
        <Table>
            <TableHeader>
                <TableRow>
                    <TableCell className="whitespace-nowrap">ID</TableCell>
                    <TableCell className="whitespace-nowrap">Nome</TableCell>
                </TableRow>
            </TableHeader>
            <TableBody>
                {ports.map(function (data, index) {
                    return <TableEquipamentPortsRow key={index} data={data} />;
                })}
            </TableBody>
        </Table>
    );
}
