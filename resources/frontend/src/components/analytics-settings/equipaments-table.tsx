import { dateExtFormatter } from "@/utils/formatter";
import { Button } from "../ui/button";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "../ui/table";
import { EquipamentsProps } from "@/services/queries/get-equipaments";

interface EquipamentsTableProps {
    equipaments: EquipamentsProps[];
}

export function EquipamentsTable({ equipaments }: EquipamentsTableProps) {
    return (
        <Table className="mt-4 w-full">
            <TableHeader>
                <TableRow>
                    <TableHead className="border-b">ID</TableHead>
                    <TableHead className="border-b">Nome</TableHead>
                    <TableHead className="border-b">Número de Portas</TableHead>
                    <TableHead className="border-b">Data de Criação</TableHead>
                    <TableHead className="border-b">
                        Data de Modificação
                    </TableHead>
                    <TableHead className="border-b"></TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                {equipaments.map((equipament) => (
                    <TableRow key={equipament._id}>
                        <TableCell className="!py-1">
                            {equipament._id}
                        </TableCell>
                        <TableCell className="!py-1">
                            {equipament.name}
                        </TableCell>
                        <TableCell className="flex items-center justify-between gap-4 !py-1 ">
                            <span>{equipament.n_port} Porta(s)</span>
                            <Button variant={"outline"} size={"sm"}>
                                Ver Portas
                            </Button>
                        </TableCell>
                        <TableCell className="!py-1">
                            {dateExtFormatter(equipament.created_at)}
                        </TableCell>
                        <TableCell className="!py-1">
                            {dateExtFormatter(equipament.updated_at)}
                        </TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}
