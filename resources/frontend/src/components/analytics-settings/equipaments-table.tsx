import { Button } from "../ui/button";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "../ui/table";

export function EquipamentsTable() {
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
                <TableRow>
                    <TableCell>661e6b214022c8e44d07fc88</TableCell>
                    <TableCell>PRJ-OLT4-DATACOM</TableCell>
                    <TableCell className="flex items-center justify-between gap-4 ">
                        <span>16</span>
                        <Button variant={"outline"} size={"sm"}>
                            Ver Portas
                        </Button>
                    </TableCell>
                    <TableCell>01/01/2024 14:00</TableCell>
                    <TableCell>01/01/2024 14:00</TableCell>
                </TableRow>

                <TableRow>
                    <TableCell>661e6b214022c8e44d07fc88</TableCell>
                    <TableCell>PRJ-OLT4-DATACOM</TableCell>
                    <TableCell className="flex items-center justify-between gap-4 ">
                        <span>16</span>
                        <Button variant={"outline"} size={"sm"}>
                            Ver Portas
                        </Button>
                    </TableCell>
                    <TableCell>01/01/2024 14:00</TableCell>
                    <TableCell>01/01/2024 14:00</TableCell>
                </TableRow>

                <TableRow>
                    <TableCell>661e6b214022c8e44d07fc88</TableCell>
                    <TableCell>PRJ-OLT4-DATACOM</TableCell>
                    <TableCell className="flex items-center justify-between gap-4 ">
                        <span>16</span>
                        <Button variant={"outline"} size={"sm"}>
                            Ver Portas
                        </Button>
                    </TableCell>
                    <TableCell>01/01/2024 14:00</TableCell>
                    <TableCell>01/01/2024 14:00</TableCell>
                </TableRow>
            </TableBody>
        </Table>
    );
}
