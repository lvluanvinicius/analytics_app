import { UserProps } from "@/services/queries/get-users";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "../ui/table";
import { dateExtFormatter } from "@/utils/formatter";
import { UsersEdit } from "./users-edit";

interface UsersTableProps {
    users: UserProps[];
}

export function UsersTable({ users }: UsersTableProps) {
    return (
        <Table className="w-full border-collapse text-left">
            <TableHeader>
                <TableRow>
                    <TableHead className="border-b">ID</TableHead>
                    <TableHead className="border-b">Nome</TableHead>
                    <TableHead className="border-b">E-mail</TableHead>
                    <TableHead className="border-b">Usuário</TableHead>
                    <TableHead className="border-b">Data de Criação</TableHead>
                    <TableHead className="border-b">
                        Data de Modificação
                    </TableHead>
                    <TableHead className="border-b"></TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                {users.map((user) => {
                    return (
                        <TableRow key={user.id}>
                            <TableCell className="border-b py-1">
                                {user.id}
                            </TableCell>
                            <TableCell className="border-b py-1">
                                {user.name}
                            </TableCell>
                            <TableCell className="border-b py-1">
                                {user.email}
                            </TableCell>
                            <TableCell className="border-b py-1">
                                {user.username}
                            </TableCell>
                            <TableCell className="border-b py-1">
                                {dateExtFormatter(user.created_at)}
                            </TableCell>
                            <TableCell className="border-b py-1">
                                {dateExtFormatter(user.updated_at)}
                            </TableCell>
                            <TableCell className="border-b py-1">
                                <UsersEdit user={{ ...user, password: "" }} />
                            </TableCell>
                        </TableRow>
                    );
                })}
            </TableBody>
        </Table>
    );
}
