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
        <div className="w-full flex-1 overflow-auto">
            <Table className="mt-4 !w-full !min-w-[600px] !border-collapse">
                <TableHeader>
                    <TableRow>
                        <TableHead className="whitespace-nowrap border-b">
                            ID
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            Nome
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            Número de Portas
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            Data de Criação
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            Data de Modificação
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b"></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {equipaments.map((equipament) => (
                        <TableRow key={equipament._id}>
                            <TableCell className="whitespace-nowrap border-b !py-1 font-medium ">
                                {equipament._id}
                            </TableCell>
                            <TableCell className="whitespace-nowrap border-b !py-1 font-medium ">
                                {equipament.name}
                            </TableCell>
                            <TableCell className="flex items-center justify-between gap-4 whitespace-nowrap border-b !py-1 font-medium ">
                                <span>{equipament.n_port} Porta(s)</span>
                                <EquipamentsViewports
                                    equipamentName={equipament.name}
                                />
                            </TableCell>
                            <TableCell className="whitespace-nowrap border-b !py-1 font-medium ">
                                {dateExtFormatter(equipament.created_at)}
                            </TableCell>
                            <TableCell className="whitespace-nowrap border-b !py-1 font-medium ">
                                {dateExtFormatter(equipament.updated_at)}
                            </TableCell>
                            <TableCell className="whitespace-nowrap border-b !py-1 font-medium ">
                                <DeleteEquipaments
                                    equipamentId={equipament._id}
                                />
                            </TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </div>
    );
}
