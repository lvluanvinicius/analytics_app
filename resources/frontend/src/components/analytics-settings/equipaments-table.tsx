import { dateExtFormatter } from "@/utils/formatter";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "../ui/table";
import { EquipamentsProps } from "@/services/queries/get-equipaments";
import { DeleteEquipaments } from "./equipaments-delete";
import { EquipamentsViewports } from "./equipaments-viewports";

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
                        <TableCell className="border-b !py-1">
                            {equipament._id}
                        </TableCell>
                        <TableCell className="border-b !py-1">
                            {equipament.name}
                        </TableCell>
                        <TableCell className="flex items-center justify-between gap-4 border-b !py-1 ">
                            <span>{equipament.n_port} Porta(s)</span>
                            <EquipamentsViewports
                                equipamentName={equipament.name}
                            />
                        </TableCell>
                        <TableCell className="border-b !py-1">
                            {dateExtFormatter(equipament.created_at)}
                        </TableCell>
                        <TableCell className="border-b !py-1">
                            {dateExtFormatter(equipament.updated_at)}
                        </TableCell>
                        <TableCell className="border-b !py-1">
                            <DeleteEquipaments equipamentId={equipament._id} />
                        </TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}
