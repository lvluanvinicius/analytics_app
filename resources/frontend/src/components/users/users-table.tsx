import { Button } from "../ui/button";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "../ui/table";

export function UsersTable() {
    return (
        <Table className="w-full border-collapse text-left">
            <TableHeader>
                <TableRow>
                    <TableHead className="border-b">ID</TableHead>
                    <TableHead className="border-b">Nome</TableHead>
                    <TableHead className="border-b">E-mail</TableHead>
                    <TableHead className="border-b">Usuário</TableHead>
                    <TableHead className="border-b">Data de Criação</TableHead>
                    <TableHead className="border-b">Data de Modificação</TableHead>
                    <TableHead className="border-b"></TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                {[0, 1, 2, 3, 4, 5, 6, 7, 8, 9].map((item) => {
                    return (
                        <TableRow key={item}>
                            <TableCell className="border-b py-1">902</TableCell>
                            <TableCell className="border-b py-1">Luan VP Santos</TableCell>
                            <TableCell className="border-b py-1">
                                lvluansantos@gmail.com
                            </TableCell>
                            <TableCell className="border-b py-1">lvluansantos</TableCell>
                            <TableCell className="border-b py-1">
                                10/10/2022 as 14:32
                            </TableCell>
                            <TableCell className="border-b py-1">
                                10/10/2022 as 14:32
                            </TableCell>
                            <TableCell className="border-b py-1">
                                <Button variant={"outline"} className="h-8">
                                    Editar
                                </Button>
                            </TableCell>
                        </TableRow>
                    );
                })}
            </TableBody>
        </Table>
    );
}
